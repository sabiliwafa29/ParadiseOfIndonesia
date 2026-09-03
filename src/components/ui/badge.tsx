import { cn } from "@/lib/utils";

interface BadgeProps extends React.HTMLAttributes<HTMLSpanElement> {
  className?: string;
}

const Badge = React.forwardRef<HTMLSpanElement, BadgeProps>({
  className: "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold",
  ...props,
}) => {
  return (
    <span className={cn("inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold", props.className)} {...props} />
  );
});

Badge.displayName = "Badge";

export { Badge };
