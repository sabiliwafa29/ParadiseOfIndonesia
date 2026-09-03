import { cn } from "@/lib/utils";

interface LabelProps extends React.LabelHTMLAttributes<HTMLLabelElement> {
  className?: string;
}

const Label = React.forwardRef<HTMLLabelElement, LabelProps>({
  className: "block text-sm font-medium text-foreground mb-1",
  ...props,
}) => {
  return (
    <label className={cn("block text-sm font-medium text-foreground mb-1", props.className)} {...props} />
  );
});

Label.displayName = "Label";

export { Label };
