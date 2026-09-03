import { cn } from "@/lib/utils";

interface CardProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const Card = React.forwardRef<HTMLDivElement, CardProps>({
  className: "rounded-lg border bg-card p-6 shadow-sm",
  ...props,
}) => {
  return (
    <div className={cn("rounded-lg border bg-card p-6 shadow-sm", props.className)} {...props} />
  );
});

Card.displayName = "Card";

export { Card };
